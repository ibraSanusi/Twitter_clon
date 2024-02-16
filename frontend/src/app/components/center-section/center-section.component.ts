import { Component } from '@angular/core';
import { Tweet, TweetResponse } from '../../shared/interfaces/tweet.interface';
import { Router } from '@angular/router';
import { TweetService } from '../../shared/services/tweet.service';
import { AuthService } from '../../shared/services/auth.service';

@Component({
  selector: 'app-center-section',
  templateUrl: './center-section.component.html',
  styleUrl: './center-section.component.css',
})
export class CenterSectionComponent {
  tweets: Tweet[] = [];

  constructor(
    private tweetService: TweetService,
    private router: Router,
    private authService: AuthService
  ) {}

  ngOnInit(): void {
    this.getFollowingTweets();
  }

  getFollowingTweets() {
    this.tweetService
      .getTweets('api/following/tweets')
      .subscribe((res: TweetResponse) => {
        this.tweets = res.data;
      });
  }
}
