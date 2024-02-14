import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../../shared/services/auth.service';
import { IUser } from '../../shared/interfaces/user.interface';
import { NgForm } from '@angular/forms';
import { HttpResponse } from '@angular/common/http';

@Component({
  selector: 'app-home',
  templateUrl: './auth.component.html',
  styleUrl: './auth.component.css',
})
export class AuthComponent {
  constructor(private authService: AuthService, private router: Router) {}

  ngOnInit(): void {}

<<<<<<< HEAD
  onSubmit(form: NgForm) {
    let client = form.value;

    console.log(client);

    const defaultValues = {
=======
  login(ngForm: NgForm) {
    const formValue = ngForm.value;

    const defaultSettings: IUser = {
>>>>>>> 03b74d4
      username: 'isanu227',
      password: 'Idele227',
    };

<<<<<<< HEAD
    console.log(defaultValues);
    // console.log(this.authService.login(client, 'angular/login'));
    return this.authService
      .login(defaultValues, 'api/login')
      .subscribe((res) => {
        console.log(res);

        const data = res.data;
        if (data) {
          this.router.navigate(['/home']);
        }
      });
=======
    console.log(defaultSettings);

    return this.authService.login(formValue, 'api/login').subscribe((res) => {
      console.log(res);

      const data = res.data;
      if (data) {
        this.router.navigate(['/home']);
      }
    });
>>>>>>> 03b74d4
  }
}
