import { Component, Input } from '@angular/core';
import { Router } from '@angular/router';
import { TweetService } from '../../shared/services/tweet.service';
import { Tweet, TweetResponse } from '../../shared/interfaces/tweet.interface';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css'], // Nota: el nombre de esta propiedad es styleUrls en lugar de styleUrl
})
export class HomeComponent {
  tweets: Tweet[] = [];

  constructor(private tweetService: TweetService, private router: Router) {}

  ngOnInit(): void {
    this.getTweets();
  }

  getTweets() {
    this.tweetService.getTweets('api/tweet').subscribe((res: TweetResponse) => {
      this.tweets = res.data;
    });
  }
}
