import { Injectable, ViewContainerRef, ComponentRef, ComponentFactory, ComponentFactoryResolver } from "@angular/core";
import { FormBuilder, FormGroup, FormControl, Validators } from "@angular/forms";
import { Router, ActivatedRoute } from "@angular/router";
import { Observable, Subscription } from "rxjs";
import { filter, map, switchMap, tap } from "rxjs/operators";
import { NgbDateParserFormatter } from "@ng-bootstrap/ng-bootstrap";
import { GeoJSON } from "leaflet";
import { ModuleConfig } from "../../module.config";
import { CommonService } from "@geonature_common/service/common.service";
import { FormService } from "@geonature_common/form/form.service";
import { DataFormService } from "@geonature_common/form/data-form.service";
import { OcctaxFormService } from "../occtax-form.service";
import { OcctaxFormMapService } from "../map/map.service";
import { OcctaxDataService } from "../../services/occtax-data.service";
import { OcctaxFormParamService } from "../form-param/form-param.service";
import { dynamicFormReleveComponent } from "../dynamique-form-releve/dynamic-form-releve.component";

@Injectable()
export class OcctaxFormReleveService {
  public userReleveRigth: any;
  public $_autocompleteDate: Subscription = new Subscription();

  public propertiesForm: FormGroup;
  public habitatForm = new FormControl();
  public releve: any;
  public geojson: GeoJSON;
  public releveForm: FormGroup;
  public showTime: boolean = false; //gestion de l'affichage des infos complémentaires de temps
  public waiting: boolean = false;
  public route: ActivatedRoute;
  
  public dynamicFormGroup: FormGroup;
  public currentIdDataset:any;
  public dynamicContainer: ViewContainerRef;
  componentRef: ComponentRef<any>;

  public datasetId : number = null;

  constructor(
    private router: Router,
    private fb: FormBuilder,
    private _commonService: CommonService,
    private dateParser: NgbDateParserFormatter,
    private coreFormService: FormService,
    private dataFormService: DataFormService,
    private occtaxFormService: OcctaxFormService,
    private occtaxFormMapService: OcctaxFormMapService,
    private occtaxDataService: OcctaxDataService,
    private occtaxParamS: OcctaxFormParamService,
    private _resolver: ComponentFactoryResolver
  ) {
    this.initPropertiesForm();
    this.setObservables();

    this.releveForm = this.fb.group({
      geometry: this.occtaxFormMapService.geometry,
      properties: this.propertiesForm,
    });
  }

  private get initialValues() {
    return {
      id_digitiser: this.occtaxFormService.currentUser.id_role,
      meta_device_entry: "web",
      observers: [this.occtaxFormService.currentUser],
    };
  }

  initPropertiesForm(): void {
    //FORM
    this.propertiesForm = this.fb.group({
      id_dataset: [null, this.datasetId ? Validators.required : null] ,
      id_digitiser: null,
      date_min: [null, Validators.required],
      date_max: [null, Validators.required],
      hour_min: [
        null,
        Validators.pattern(
          "^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$"
        ),
      ],
      hour_max: [
        null,
        Validators.pattern(
          "^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$"
        ),
      ],
      altitude_min: null,
      altitude_max: null,
      depth_min: null,
      depth_max: null,
      place_name: null,
      meta_device_entry: null,
      comment: null,
      cd_hab: null,
      id_nomenclature_tech_collect_campanule: null,
      observers: [
        null,
        !ModuleConfig.observers_txt ? Validators.required : null,
      ],
      observers_txt: [
        null,
        ModuleConfig.observers_txt ? Validators.required : null,
      ],
      id_nomenclature_grp_typ: null,
      grp_method: null,
      id_nomenclature_geo_object_nature: null,
      precision: null
    });

    this.propertiesForm.patchValue(this.initialValues);

    // VALIDATORS
    this.propertiesForm.setValidators([
      this.coreFormService.dateValidator(
        this.propertiesForm.get("date_min"),
        this.propertiesForm.get("date_max")
      ),
      this.coreFormService.hourAndDateValidator(
        this.propertiesForm.get("date_min"),
        this.propertiesForm.get("date_max"),
        this.propertiesForm.get("hour_min"),
        this.propertiesForm.get("hour_max")
      ),
      this.coreFormService.minMaxValidator(
        this.propertiesForm.get("altitude_min"),
        this.propertiesForm.get("altitude_max"),
        "invalidAlt"
      ),
      this.coreFormService.minMaxValidator(
        this.propertiesForm.get("depth_min"),
        this.propertiesForm.get("depth_max"),
        "invalidDepth"
      ),
    ]);

    //on desactive le form, il sera réactivé si la geom est ok
    this.propertiesForm.disable();
    this.occtaxParamS.parameters.releve.id_dataset = 1;
  }
  
  onDatasetChanged(idDataset) {
    this.currentIdDataset = idDataset;
    //this.octaxForm.createComponent();
    this.dynamicContainer.clear(); 
    const factory: ComponentFactory<any> = this._resolver.resolveComponentFactory(dynamicFormReleveComponent);
    this.componentRef = this.dynamicContainer.createComponent(factory);

    this.componentRef.instance.formConfigReleveDataSet = ModuleConfig.add_fields[this.currentIdDataset]['releve'];
    this.componentRef.instance.formArray = this.dynamicFormGroup;
    /*this.dynamicDatasetForm = this._fb.group({
      test: null,
    });*/
  }

  /**
   * Initialise les observables pour la mise en place des actions automatiques
   **/
  private setObservables() {
    //patch le form par les valeurs par defaut si creation
    this.occtaxFormService.editionMode
      .pipe(
        tap((editionMode: boolean) => {
          // gestion de l'autocomplétion de la date ou non.
          this.$_autocompleteDate.unsubscribe();
          // autocomplete si mode création ou si mode edition et date_min = date_max
          if (!editionMode) {
            this.$_autocompleteDate = this.coreFormService.autoCompleteDate(
              this.propertiesForm as FormGroup,
              "date_min",
              "date_max"
            );
          }
        }),
        switchMap((editionMode: boolean) => {
          //Le switch permet, selon si édition ou creation, de récuperer les valeur par defaut ou celle de l'API
          return editionMode ? this.releveValues : this.defaultValues;
        })
      )
      .subscribe((values) => this.propertiesForm.patchValue(values)); //filter((editionMode: boolean) => !editionMode))

    //Observation de la geometry pour récupere les info d'altitudes
    this.occtaxFormMapService.geojson
      .pipe(
        filter((geojson) => geojson !== null),
        tap((geojson) => {
          //geom valide
          if (!this.occtaxFormService.editionMode.getValue()) {
            //recup des info d'altitude uniquement en mode creation
            this.getAltitude(geojson);
          }
          this.propertiesForm.enable(); //active le form
        })
      )
      .subscribe((geojson) => (this.geojson = geojson));

    // AUTOCORRECTION de hour
    // si le champ est une chaine vide ('') on reset la valeur null
    this.propertiesForm
      .get("hour_min")
      .valueChanges.pipe(filter((hour) => hour && hour.length == 0))
      .subscribe((hour) => {
        this.propertiesForm.get("hour_min").reset();
      });

    this.propertiesForm
      .get("hour_max")
      .valueChanges.pipe(filter((hour) => hour && hour.length == 0))
      .subscribe((hour) => {
        this.propertiesForm.get("hour_max").reset();
      });

    // AUTOCOMPLETE DE hour_max par hour_min UNIQUEMENT SI editionMode = FAUX
    this.propertiesForm
      .get("hour_min")
      .valueChanges.pipe(
        filter(
          (hour) =>
            !this.occtaxFormService.editionMode.getValue() && hour != null
        )
      )
      .subscribe((hour) => {
        if (
          // autcomplete only if hour max is empty or invalid
          this.propertiesForm.get("hour_max").invalid ||
          this.propertiesForm.get("hour_max").value == null
        ) {
          this.propertiesForm.get("hour_max").setValue(hour);
        }
      });
  }

  /** Get occtax data and patch value to the form */
  private get releveValues(): Observable<any> {
    return this.occtaxFormService.occtaxData.pipe(
      filter((data) => data && data.releve.properties),
      map((data) => {
        const releve = data.releve.properties;

        // on affiche la date_max si date_min != date_max
        if (releve.date_min != releve.date_max) {
          this.showTime = true;
        }
        // si les date sont égales, on active l'autocomplete pour garder la correlation
        else {
          this.$_autocompleteDate.unsubscribe()
          this.$_autocompleteDate = this.coreFormService.autoCompleteDate(
            this.propertiesForm as FormGroup,
            "date_min",
            "date_max"
          );
        }

        releve.date_min = this.formatDate(releve.date_min);
        releve.date_max = this.formatDate(releve.date_max);


        // set habitat form value from 
        if (releve.habitat) {
          const habitatFormValue = releve.habitat;
          // set search_name properties to the form
          habitatFormValue['search_name'] = habitatFormValue.lb_code + " - " + habitatFormValue.lb_hab_fr;
          this.habitatForm.setValue(habitatFormValue)
        }

        /*MET Champs additionnel*/
        this.dynamicFormGroup = this.fb.group({});
        if (releve.additional_fields){
          for (const key of Object.keys(releve.additional_fields)){
            releve[key] =  releve.additional_fields[key];
            this.dynamicFormGroup.value[key] = releve.additional_fields[key];
            //console.log(key + "->" + releve.additional_fields[key]);
          }
        }

        return releve;
      })
    );
  }

  private defaultDateWithToday() {
    if (!ModuleConfig.DATE_FORM_WITH_TODAY) {
      return null;
    } else {
      const today = new Date();
      return {
        year: today.getFullYear(),
        month: today.getMonth() + 1,
        day: today.getDate(),
      };
    }
  }

  private get defaultValues(): Observable<any> {
    return this.occtaxFormService
      .getDefaultValues(this.occtaxFormService.currentUser.id_organisme)
      .pipe(
        map((data) => {
          return {
            id_dataset: this.occtaxParamS.get("releve.id_dataset") || this.datasetId,
            date_min:
              this.occtaxParamS.get("releve.date_min") ||
              this.defaultDateWithToday(),
            date_max: this.occtaxParamS.get("releve.date_max"),
            hour_min: this.occtaxParamS.get("releve.hour_min"),
            hour_max: this.occtaxParamS.get("releve.hour_max"),
            altitude_min: this.occtaxParamS.get("releve.altitude_min"),
            altitude_max: this.occtaxParamS.get("releve.altitude_max"),
            meta_device_entry: "web",
            comment: this.occtaxParamS.get("releve.comment"),
            observers: this.occtaxParamS.get("releve.observers") || [
              this.occtaxFormService.currentUser,
            ],
            observers_txt: this.occtaxParamS.get("releve.observers_txt"),
            id_nomenclature_grp_typ:
              this.occtaxParamS.get("releve.id_nomenclature_grp_typ") ||
              data["TYP_GRP"],
            grp_method: this.occtaxParamS.get("releve.grp_method"),
            id_nomenclature_tech_collect_campanule:
              this.occtaxParamS.get("releve.id_nomenclature_tech_collect_campanule") ||
              data["TECHNIQUE_OBS"],
            id_nomenclature_geo_object_nature:
              this.occtaxParamS.get(
                "releve.id_nomenclature_geo_object_nature"
              ) || data["NAT_OBJ_GEO"],
          };
        })
      );
  }

  private getAltitude(geojson) {
    // get to geo info from API
    this.dataFormService.getGeoInfo(geojson).subscribe((res) => {
      this.propertiesForm.patchValue({
        altitude_min: res.altitude.altitude_min,
        altitude_max: res.altitude.altitude_max,
      });
    });
  }

  private formatDate(strDate) {
    const date = new Date(strDate);
    return {
      year: date.getFullYear(),
      month: date.getMonth() + 1,
      day: date.getDate(),
    };
  }

  get releveFormValue() {
    let value = this.releveForm.value;
    value.properties.date_min = this.dateParser.format(
      value.properties.date_min
    );
    value.properties.date_max = this.dateParser.format(
      value.properties.date_max
    );
    value.properties.observers = value.properties.observers.map(
      (observer) => observer.id_role
    );
    /*value.properties.id_dataset = value.properties.id_dataset.map(
      (dataset) => dataset.id_dataset
    );*/
    //value.champs_addi = this.occtaxFormService.componentRef.instance.formArray.value;
    return value;
  }

  submitReleve() {
    this.waiting = true;
    this.releveForm.value['additional_fields'] = this.componentRef.instance.formArray.value;

    if (this.occtaxFormService.id_releve_occtax.getValue()) {
      //update
      this.occtaxDataService
        .updateReleve(
          this.occtaxFormService.id_releve_occtax.getValue(),
          this.releveFormValue
        )
        .pipe(tap(() => (this.waiting = false)))
        .subscribe(
          (data: any) => {
            this._commonService.translateToaster(
              "info",
              "Releve.Infos.ReleveModified"
            );
            this.occtaxFormService.replaceReleveData(data);
            this.releveForm.markAsPristine();
            this.router.navigate(["taxons"], {
              relativeTo: this.route,
            });
          },
          (err) => {
            this.waiting = false;
            this._commonService.translateToaster("error", "ErrorMessage");
          }
        );
    } else {
      //create
      this.occtaxDataService
        .createReleve(this.releveFormValue)
        .pipe(tap(() => (this.waiting = false)))
        .subscribe(
          (data: any) => {
            this._commonService.translateToaster(
              "info",
              "Releve.Infos.ReleveAdded"
            );
            this.router.navigate([data.id, "taxons"], {
              relativeTo: this.route,
            });
          },
          (err) => {
            this.waiting = false;
            this._commonService.translateToaster("error", "ErrorMessage");
          }
        );
    }
  }

  reset() {
    this.propertiesForm.reset(this.initialValues);
    this.propertiesForm.disable();
  }
}
