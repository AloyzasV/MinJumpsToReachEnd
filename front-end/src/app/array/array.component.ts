import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { HttpClient, HttpHeaders } from '@angular/common/http';

@Component({
  selector: 'app-array',
  templateUrl: './array.component.html',
  styleUrls: ['./array.component.css']
})

export class ArrayComponent implements OnInit {
  public form: FormGroup;
  public elements: FormArray;
  public steps: any;
  public message: any;
  public path = [];

  get elementFormGroup() {
    return this.form.get('numbers_array') as FormArray;
  }

  constructor(private fb: FormBuilder, private http: HttpClient) {}

  ngOnInit() {
    this.form = this.fb.group({
      numbers_array: this.fb.array([this.createElement()])
    });

    this.steps = null;
    this.path = null;
    this.elements = this.form.get('numbers_array') as FormArray;
  }

  createElement(): FormGroup {
    return this.fb.group({
      element: [null, Validators.compose([Validators.required])],
    });
  }

  addElement() {
    this.elements.push(this.createElement());
  }

  removeElement(index) {
    this.elements.removeAt(index);
  }

  getElementFormGroup(index): FormGroup {
    const formGroup = this.elements.controls[index] as FormGroup;
    return formGroup;
  }

  submit() {
    this.http.post(`http://localhost/danske-assigment/back-end/public/api/find-shortest-path`, this.form.value)
    .toPromise().then((data:any) => {
      this.steps = data.steps;
      this.message = data.message;
      this.path = data.path;
    })
  }
}