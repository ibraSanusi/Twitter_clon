import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { BeaWhisperingComponent } from '@shared/components/icons/bea-whispering/bea-whispering.component';
import { IUser, LoginUser } from '@core/models/user.interface';
import { FormsModule, NgForm } from '@angular/forms';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [BeaWhisperingComponent, FormsModule],
  templateUrl: './auth-page.component.html',
  styleUrl: './auth-page.component.css',
})
export class AuthPageComponent {
  constructor(private authService: AuthService, private router: Router) {}

  ngOnInit(): void {}

  login(ngForm: NgForm) {
    const formValue = ngForm.value;

    const defaultSettings: LoginUser = {
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
