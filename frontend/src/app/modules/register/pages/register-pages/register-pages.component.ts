import { Component } from '@angular/core';
import { FormsModule, NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { RegisterService } from '@modules/register/services/register.service';

@Component({
  selector: 'app-register-pages',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './register-pages.component.html',
  styleUrl: './register-pages.component.css',
})
export class RegisterPagesComponent {
  constructor(private http: RegisterService, private router: Router) {}

  register(ngForm: NgForm) {
    const formValue = ngForm.value;
    this.http.register(formValue, '/api/register').subscribe((res) => {
      console.log('Respuesta del registro: [' + res + ']');
      const data = res;
      if (data) {
        this.router.navigate(['/auth/login']);
      }
    });
  }
}
