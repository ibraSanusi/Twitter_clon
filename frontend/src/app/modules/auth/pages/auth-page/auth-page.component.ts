import { Component } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { BeaWhisperingComponent } from '@shared/components/icons/bea-whispering/bea-whispering.component';
import { IUser, LoginUser } from '@core/models/user.interface';
import { FormsModule, NgForm } from '@angular/forms';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [BeaWhisperingComponent, FormsModule, RouterLink],
  templateUrl: './auth-page.component.html',
  styleUrl: './auth-page.component.css',
})
export class AuthPageComponent {
  constructor(private authService: AuthService, private router: Router) {}

  ngOnInit(): void {}

  login(ngForm: NgForm) {
    const formValue = ngForm.value;

    return this.authService.login(formValue, 'api/login').subscribe((res) => {
      console.log(res);

      const data = res.data;
      if (data) {
        if (data.roles) this.router.navigate(['/home']);
      }
    });
  }
}
