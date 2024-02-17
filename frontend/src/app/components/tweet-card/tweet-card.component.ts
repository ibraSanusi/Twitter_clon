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
    const likedTweet: Like = {
      tweetId: id,
    };

    const tweet = this.tweets.find((tweet) => tweet.id === id);
    if (tweet) {
      tweet.liked = !tweet.liked;

      // Si antes no tenia un like y ahora lo tiene lo anadimos a la bbdd
      // Sino lo eliminamos
      if (tweet.liked) {
        const deslike: Like = {
          tweetId: id,
        };

        // Borrar el like de la base de datos
        this.tweetService.delete(deslike, 'api/like').subscribe((res) => {
          console.log(res);
        });
      } else {
        this.tweetService
          .post(likedTweet, 'api/delete/like')
          .subscribe((res: any) => {
            console.log(res);
          });
      }
    }

    console.log('Estructura del tweetId: ' + tweet);
  }
}
