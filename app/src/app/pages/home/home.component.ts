import { Component } from '@angular/core';
import { AuthService } from '../../shared/services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrl: './home.component.css',
})
export class HomeComponent {
  constructor(private authService: AuthService, private router: Router) {}

  ngOnInit(): void {
    this.getTweets();
  }

  getTweets() {
    return this.authService.getTweets('angular').subscribe((res) => {
      console.log(res);
    });
  }
}
