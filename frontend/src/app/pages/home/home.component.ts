import { Component, Input } from '@angular/core';
import { Router } from '@angular/router';
import { TweetService } from '../../shared/services/tweet.service';
import { Tweet, TweetResponse } from '../../shared/interfaces/tweet.interface';
import { AuthService } from '../../shared/services/auth.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css'], // Nota: el nombre de esta propiedad es styleUrls en lugar de styleUrl
})
export class HomeComponent {
  tweets: Tweet[] = [];

  constructor(
    private tweetService: TweetService,
    private router: Router,
    private authService: AuthService
  ) {}

  ngOnInit(): void {
    this.getFollowingTweets();
  }

  getTweets() {
    this.tweetService
      .getTweets('api/tweets')
      .subscribe((res: TweetResponse) => {
        this.tweets = res.data;
      });
  }

  getFollowingTweets() {
    this.tweetService
      .getTweets('api/following/tweets')
      .subscribe((res: TweetResponse) => {
        this.tweets = res.data;
      });
  }

  getSessionIdFromCookie(): string | null {
    const sessionIdCookie = document.cookie
      .split('; ')
      .find((row) => row.startsWith('PHPSESSID='));

    return sessionIdCookie ? sessionIdCookie.split('=')[1] : null;
  }
}
