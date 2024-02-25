import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '@shared/services/auth.service';
import { TweetService } from '@shared/services/tweet.service';
import { SearchIconComponent } from '../icons/search-icon/search-icon.component';
import { ProfileIconComponent } from '../icons/profile-icon/profile-icon.component';
import { SettingIconComponent } from '../icons/setting-icon/setting-icon.component';

@Component({
  selector: 'menu-bar',
  standalone: true,
  imports: [SearchIconComponent, ProfileIconComponent, SettingIconComponent],
  templateUrl: './menu-bar.component.html',
  styleUrl: './menu-bar.component.css',
})
export class MenuBarComponent {
  constructor(
    private tweetService: TweetService,
    private router: Router,
    private authService: AuthService
  ) {}

  logout() {
    this.authService.logout('api/logout').subscribe((res) => {
      console.log('Se cerro sesion correctamente: ' + res);
      console.log(document.cookie.valueOf());
      // window.location.reload();
    });
  }
}
