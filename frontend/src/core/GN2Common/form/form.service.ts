import { Injectable } from '@angular/core';
import { FormControl, FormBuilder, FormGroup, FormArray, Validators } from '@angular/forms';
import {  } from '@angular/forms';

@Injectable()
export class FormService {
  currentTaxon:any;
  municipalities: string;
  indexCounting: number;
  nbCounting: Array<string>;
  contactForm: FormGroup;
  occurrenceForm : FormGroup;
  countingForm: FormArray;
  indexOccurrence: number = 0;

  constructor(private _fb: FormBuilder) {
    this.currentTaxon = {};
    this.indexCounting = 0;
    this.nbCounting = [''];
   }// end constructor

   initObservationForm(data?): FormGroup {
    return this._fb.group({
      geometry: [data ? data.geometry: null, Validators.required],
      properties: this._fb.group({
        id_dataset: [data ? data.properties.id_dataset:null, Validators.required],
        id_digitiser : null,
        date_min: [data ? this.formatDate(data.properties.date_min): null, Validators.required],
        date_max: [data ? this.formatDate(data.properties.date_max): null, Validators.required],
        altitude_min: data ? data.properties.altitude_min: null,
        altitude_max : data ? data.properties.altitude_max: null,
        deleted: false,
        municipalities : null,
        meta_device_entry: 'web',
        comment: data ? data.properties.comment: null,
        observers: [data ? this.formatObservers(data.properties.observers): null, Validators.required],
        t_occurrences_contact: this._fb.array([])
      })
    });
   }

   initOccurrenceForm(data?): FormGroup {
    return this._fb.group({
      id_nomenclature_obs_technique : [data ? data.id_nomenclature_obs_technique : null, Validators.required],
      id_nomenclature_obs_meth: data ? data.id_nomenclature_obs_meth : null,
      id_nomenclature_bio_condition: [data ? data.id_nomenclature_bio_condition : null, Validators.required],
      id_nomenclature_bio_status : data ? data.id_nomenclature_bio_status : null,
      id_nomenclature_naturalness : data ? data.id_nomenclature_naturalness : null,
      id_nomenclature_exist_proof: data ? data.id_nomenclature_exist_proof : null,
      id_nomenclature_valid_status: data ? data.id_nomenclature_valid_status : null,
      id_nomenclature_diffusion_level: data ? data.id_nomenclature_diffusion_level : null,
      id_validator: null,
      determiner: '',
      determination_method: data ? data.determination_method : '',
      cd_nom: [data ? data.cd_nom : null, Validators.required],
      nom_cite: data ? data.nom_cite : '',
      meta_v_taxref: "Taxref V9.0",
      sample_number_proof: data ? data.sample_number_proof : '',
      digital_proof: data ? data.digital_proof : '',
      non_digital_proof:data ? data.non_digital_proof : '',
      deleted: false,
      comment: data ? data.comment : '',
      cor_counting_contact: ''
    })
  }


   initCounting(data?): FormGroup {
    return this._fb.group({
      id_nomenclature_life_stage: [data ? data.id_nomenclature_life_stage : null, Validators.required],
      id_nomenclature_sex: [data ? data.id_nomenclature_sex : null, Validators.required],
      id_nomenclature_obj_count: [data ? data.id_nomenclature_obj_count : null, Validators.required],
      id_nomenclature_type_count: data ? data.id_nomenclature_type_count : null,
      count_min : data ? data.count_min : null,
      count_max : data ? data.count_max : null
    });
    }


  initCountingArray(data?: Array<any>): FormArray {
    const arrayForm = this._fb.array([]);

    if (data) {
      for (let i = 0; i < data.length; i++) {
        arrayForm.push(this.initCounting(data[i]));
      }
    } else {
      arrayForm.push(this.initCounting());
    }
    return arrayForm;
  }

  addOccurence(occurenceForm: FormGroup, observationForm: FormGroup, countingForm: FormArray, edit?) {
    // push the counting(s) in occurrenceForm
    occurenceForm.controls.cor_counting_contact.patchValue(countingForm.value);
    // push or edit the current occurence in the observationForm
    if (observationForm.value.properties.t_occurrences_contact.length === this.indexOccurrence) {
      observationForm.value.properties.t_occurrences_contact.push(occurenceForm.value);
    }else {
      observationForm.value.properties.t_occurrences_contact[this.indexOccurrence] = occurenceForm.value;
    }
    // reset counting
    this.nbCounting = [''];
    this.indexCounting = 0;
    // reset current taxon
    this.currentTaxon = {};
  }

  addCounting(countingForm: FormArray) {
    this.indexCounting += 1;
    this.nbCounting.push('');
    const countingCtrl = this.initCounting();
    countingForm.push(countingCtrl);
    }

  removeCounting(index: number, countingForm: FormArray) {
    //countingForm.controls.splice(index, 1);
    countingForm.removeAt(index);
    countingForm.value.splice(index, 1);
    this.nbCounting.splice(index, 1);
    console.log(countingForm);
    // check if is valid
    let valid = true;
    countingForm.controls.forEach((control) => {
      if (!control.valid) {
        valid = false;
      }
    });
     


  }

  updateTaxon(taxon) {
     this.currentTaxon = taxon;
   }

  formatObservers(observers){
    const observersTab = [];
    observers.forEach(observer => {
      observer['nom_complet'] = observer.nom_role + ' ' + observer.prenom_role
      observersTab.push(observer);
    });
    return observersTab;
  }

  formatDate(strDate) {
    const date = new Date(strDate);
    return {
      'year': date.getFullYear(),
      'month': date.getMonth() + 1,
      'day': date.getDate()
    }
  }



}