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

  login(ngForm: NgForm) {
    const formValue = ngForm.value;

    const defaultSettings: IUser = {
      username: 'isanu227',
      password: 'Idele227',
    };

    console.log(defaultSettings);

    return this.authService.login(formValue, 'api/login').subscribe((res) => {
      console.log(res);

      const data = res.data;
      if (data) {
        this.router.navigate(['/home']);
      }
    });
  }
}
