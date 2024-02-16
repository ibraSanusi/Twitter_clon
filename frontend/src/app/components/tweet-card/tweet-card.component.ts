import { Component, Input } from '@angular/core';
import { Like, Tweet } from '../../shared/interfaces/tweet.interface';
import { TweetService } from '../../shared/services/tweet.service';

@Component({
  selector: 'app-tweet-card',
  templateUrl: './tweet-card.component.html',
  styleUrls: ['./tweet-card.component.css'],
})
export class TweetCardComponent {
  @Input() tweets: Tweet[] = [];

  constructor(private tweetService: TweetService) {}

  likeTweet(id: number) {
    const tweet: Like = {
      tweetId: id,
    };
    console.log('Estructura del tweetId: ' + tweet);
    this.tweetService.post(tweet, 'api/like/tweet').subscribe((res: any) => {
      console.log(res);
      // Si se dio like correctamente al tweet cambiarmos la propiedad liked del tweet a true
      // Primero hay que buscarlo por id
      if (!res) return;

      const likedTweet = this.tweets.find((tweet) => tweet.id === id);
      if (likedTweet) {
        likedTweet.liked = true;
      }
    });
  }
}
