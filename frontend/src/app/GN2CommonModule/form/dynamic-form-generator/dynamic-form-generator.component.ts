import { Component, OnInit, OnChanges, Input, Output, EventEmitter } from '@angular/core';
import { FormGroup, FormControl } from '@angular/forms';
import { DynamicFormService } from './dynamic-form.service';
import * as equal from 'fast-deep-equal/es6';

/**
 * Ce composant permet de créer dynamiquement des formulaire à partir
 * de paramètres passés sous forme d'un tableau d'objets.
 */
@Component({
  selector: 'pnx-dynamic-form-generator',
  templateUrl: './dynamic-form-generator.component.html',
  styleUrls: ['./dynamic-form-generator.component.scss']
})
export class GenericFormGeneratorComponent implements OnInit, OnChanges {
  public formControlBuilded = false;
  public selectControl = new FormControl();

  public formsHidden = [];
  public formsDisplayed = [];

  public oldValue = {};
  public update;

  @Input() myFormGroup: FormGroup;
  @Output() myFormGroupChange = new EventEmitter<any>();

  @Input() formsDefinition: Array<any>;
  @Input() selectLabel: string;

  @Output() change = new EventEmitter<any>();

  /**
   * Est-ce que le formulaire doit être controlé par un champ select pour
   * afficher/masquer les champs du formulaire.
   * Par défault le formulaire n'est pas controlé par un champ select.
   */
  @Input() autoGenerated = false;
  public formsSelected = [];

  constructor(private _dynformService: DynamicFormService) {}

  ngOnInit() {
    this.formsDefinition = this.formsDefinition || [];
    this.initDynamicForm();
    this.myFormGroup.valueChanges.subscribe(values => {
      this.onFormsChange(values);
    });
  }

  ngOnChanges(changes) {
    // on formdef changes, regenerate the form and UI
    // Do not load the form at first change: done by ngOnInit which wait for the component to be ready    
    if(changes.formsDefinition && !changes.formsDefinition.firstChange && changes.formsDefinition.currentValue) {      
      for (const controlName in this.myFormGroup.controls) {
        this.myFormGroup.removeControl(controlName)
      }
      this.initDynamicForm();
      console.log("###################");
      console.log(changes.formsDefinition.currentValue);
      
      
    }
  }

  initDynamicForm() {
    if (this.autoGenerated) {
      if (!this.myFormGroup) {
        this.myFormGroup = this._dynformService.initFormGroup();
      }

      // HACK: formeSelect = formDefinition en mode autoGenerated = true
      // (on affiche tous les champs sans les filtrer au préalable)
      this.formsSelected = this.formsDefinition;
      this.formsDefinition.forEach(formDef => {
        if (formDef.type_widget) {
          this._dynformService.addNewControl(formDef, this.myFormGroup);
        }
      });

    } else {
      this.selectControl.valueChanges
        .filter(value => value !== null)
        .subscribe(formDef => {
          this.addFormControl(formDef);
        });
      this.formsDefinition.sort((a, b) => {
        return a.attribut_label.localeCompare(b.attribut_label);
      });
    }
    this.setForms();
    this.formControlBuilded = true;
    this.myFormGroupChange.emit(this.myFormGroup);
  }

  /**
   * on teste s'il y a un changement entre this.myFormGroup.value et valueSaved;
   */
  hasValueChanged(newValue) {
    return !equal(newValue, this.oldValue);
  }

  setForms() {
    this.formsDisplayed = this.formsSelected.filter(
      formDef => !this._dynformService.getFormDefValue(formDef, 'hidden', this.myFormGroup.value)
    );
    this.formsHidden = this.formsSelected.filter(formDef =>
      this._dynformService.getFormDefValue(formDef, 'hidden', this.myFormGroup.value)
    );
  }

  onFormsChange(newValue) {
    if (this.hasValueChanged(newValue)) {
      // mise à jour des formulaires affichés / cachés
      this.setForms();

      // pour dire aux formulaires qu'il y a un changement;
      this.update = true;
      setTimeout(() => {
        this.update = false;
      }, 500);

      this.change.emit(newValue);
      this.oldValue = { ...newValue };
    }
  }

  removeFormControl(i) {
    const formDef = this.formsSelected[i];
    this.formsSelected.splice(i, 1);
    this.formsDefinition.push(formDef);
    this.myFormGroup.removeControl(formDef.attribut_name);
    this.selectControl.setValue(null);
  }

  addFormControl(formDef) {
    this.formsSelected.push(formDef);
    this.formsDefinition = this.formsDefinition.filter(form => {
      return form.attribut_name !== formDef.attribut_name;
    });
    this._dynformService.addNewControl(formDef, this.myFormGroup);
    // pour être sûr que les composants (displayed et hidden) soient bien mis à jour)
    this.setForms();
  }
}
