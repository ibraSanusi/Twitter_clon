<<<<<<< HEAD
import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { TweetService } from '../../shared/services/tweet.service';
=======
import { Component, Input } from '@angular/core';
import { Router } from '@angular/router';
import { TweetService } from '../../shared/services/tweet.service';
import { Tweet, TweetResponse } from '../../shared/interfaces/tweet.interface';
import { AuthService } from '../../shared/services/auth.service';
>>>>>>> 03b74d4

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css'], // Nota: el nombre de esta propiedad es styleUrls en lugar de styleUrl
})
export class HomeComponent {
<<<<<<< HEAD
  constructor(private tweetService: TweetService, private router: Router) {}
=======
  tweets: Tweet[] = [];

  constructor(
    private tweetService: TweetService,
    private router: Router,
    private authService: AuthService
  ) {}
>>>>>>> 03b74d4

  ngOnInit(): void {
    this.getFollowingTweets();
  }

  getTweets() {
<<<<<<< HEAD
    const sessionId = this.getSessionIdFromCookie();
    if (!sessionId) return null;

    console.log('Session ID => ' + sessionId);

    return this.tweetService.getTweets('api/tweet').subscribe((res) => {
      console.log(res);
    });
=======
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
>>>>>>> 03b74d4
  }

  getSessionIdFromCookie(): string | null {
    const sessionIdCookie = document.cookie
      .split('; ')
      .find((row) => row.startsWith('PHPSESSID='));

    return sessionIdCookie ? sessionIdCookie.split('=')[1] : null;
  }
}
