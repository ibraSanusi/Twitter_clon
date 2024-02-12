import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { TweetService } from '../../shared/services/tweet.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrl: './home.component.css',
})
export class HomeComponent {
  constructor(private tweetService: TweetService, private router: Router) {}

  ngOnInit(): void {
    this.getTweets();
  }

  getTweets() {
    const sessionId = this.getSessionIdFromCookie();
    if (!sessionId) return null;

    console.log('Session ID => ' + sessionId);

    return this.tweetService.getTweets('api/tweet').subscribe((res) => {
      console.log(res);
    });
  }

  getSessionIdFromCookie(): string | null {
    const sessionIdCookie = document.cookie
      .split('; ')
      .find((row) => row.startsWith('PHPSESSID='));

    return sessionIdCookie ? sessionIdCookie.split('=')[1] : null;
  }
}
