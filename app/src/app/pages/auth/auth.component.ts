import { Component } from '@angular/core';
import { NgForm } from '@angular/forms';
import { AuthService } from '../../shared/services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-auth',
  templateUrl: './auth.component.html',
  styleUrl: './auth.component.css',
})
export class AuthComponent {
  constructor(private authService: AuthService, private router: Router) {}

  ngOnInit(): void {}

  onSubmit(form: NgForm) {
    let client = form.value;

    console.log(client);

    const defaultValues = {
      username: 'isanu227',
      password: 'Idele227',
    };

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
  }
}
