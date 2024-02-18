import { Injectable } from '@angular/core';
import { Tweet, TweetResponse } from '../interfaces/tweet.interface';
import { TweetService } from '../services/tweet.service';
import { Router } from '@angular/router';
import { AuthService } from '../services/auth.service';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class TweetGlobalService {
  tweets: Tweet[] = [];

  constructor(
    private tweetService: TweetService,
    private router: Router,
    private authService: AuthService
  ) {
    this.getFollowingTweets(); // Llama al método al instanciar el servicio
  }

  private getFollowingTweets() {
    this.tweetService
      .get('api/following/tweets')
      .subscribe((res: TweetResponse) => {
        this.tweets = res.data;
      });
  }

  getTweets(): Observable<TweetResponse> {
    return this.tweetService.get('api/following/tweets');
  }
}
