import { Component } from '@angular/core';
import { TweetService } from '../../shared/services/tweet.service';
import { Router } from '@angular/router';
import { AuthService } from '../../shared/services/auth.service';

@Component({
  selector: 'app-left-section',
  templateUrl: './left-section.component.html',
  styleUrl: './left-section.component.css',
})
export class LeftSectionComponent {
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
