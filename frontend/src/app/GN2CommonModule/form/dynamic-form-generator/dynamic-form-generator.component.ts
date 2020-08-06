import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { FormGroup, FormControl } from '@angular/forms';
import { DynamicFormService } from './dynamic-form.service';

/**
 * Ce composant permet de créer dynamiquement des formulaire à partir d'un modèle JSON
 */
@Component({
  selector: 'pnx-dynamic-form-generator',
  templateUrl: './dynamic-form-generator.component.html',
  styleUrls: ['./dynamic-form-generator.component.scss']
})
export class GenericFormGeneratorComponent implements OnInit {
  public formControlBuilded = false;
  public selectControl = new FormControl();
  @Input() myFormGroup: FormGroup;
  @Input() formsDefinition: Array<any>;
  @Input() selectLabel: string;
  /**
   * Est-ce que le formulaire doit être controlé par un champ select pour afficher/masquer les champs du formulaire
   * Par défault le formulaire est controlé par un champ select
   */
  @Input() autoGenerated = false;
  public formsSelected = [];
  public formsSelectedHidden = [];

  constructor(private _dynformService: DynamicFormService) {}

  ngOnInit() {
    if (this.autoGenerated) {
      // HACK: formeSelect = formDefinition en mode autoGenerated = true (on affiche tous les champs sans les filtrer au préalable)
      // this.formsSelected = this.formsDefinition;
      this.formsSelected = this.formsDefinition.filter(e => !e.hidden);
      this.formsSelectedHidden = this.formsDefinition.filter(e => e.hidden);
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
    this.formControlBuilded = true;
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
  }
}
