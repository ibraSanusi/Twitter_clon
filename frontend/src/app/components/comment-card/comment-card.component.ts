import { Component, OnInit } from '@angular/core';
import { Tweet, TweetId } from '../../shared/interfaces/tweet.interface';
import { TweetService } from '../../shared/services/tweet.service';
import { TweetGlobalService } from '../../shared/global/tweetGlobal.service';

@Component({
  selector: 'app-comment-card',
  templateUrl: './comment-card.component.html',
  styleUrl: './comment-card.component.css',
})
export class CommentCardComponent implements OnInit {
  tweets: Tweet[] = [];

  constructor(
    private tweetService: TweetService,
    protected _tweets: TweetGlobalService
  ) {}

  ngOnInit(): void {
    this.tweets = this._tweets.getTweets();
  }

  // Like or Dislike
  like(id: number) {
    const tweetId: TweetId = {
      tweetId: id,
    };

    const tweet = this.tweets.find((tweet) => tweet.id === id);
    if (tweet) {
      tweet.liked = !tweet.liked;

      // Si antes no tenia un like y ahora lo tiene lo anadimos a la bbdd
      // Sino lo eliminamos
      if (tweet.liked) {
        this.tweetService.post(tweetId, 'api/like').subscribe((res) => {
          console.log(res);
        });
      } else {
        // Borrar el like de la base de datos
        this.tweetService
          .post(tweetId, 'api/delete/like')
          .subscribe((res: any) => {
            console.log(res);
          });
      }
    }

    console.log('Estructura del tweetId: ' + tweet);
  }

  // Retweetear o Desretweetear
  retweet(id: number) {
    const tweetId: TweetId = {
      tweetId: id,
    };

    // Primero buscamos el tweet para luego agregarlo o eliminarlo
    const tweet = this.tweets.find((tweet) => tweet.id === id);
    if (tweet) {
      tweet.retweeted = !tweet.retweeted;

      // Si antes no tenia un retweet y ahora lo tiene lo anadimos a la bbdd
      // Sino lo eliminamos
      if (tweet.retweeted) {
        this.tweetService.post(tweetId, 'api/retweet').subscribe((res) => {
          console.log(res);
        });
      } else {
        // Borrar el retweet de la base de datos
        this.tweetService
          .post(tweetId, 'api/delete/retweet')
          .subscribe((res: any) => {
            console.log(res);
          });
      }
    }

    console.log('Estructura del tweetId: ' + tweet);
  }
}
