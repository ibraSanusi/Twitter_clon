import { Component, Input } from '@angular/core';
import { CommentIconComponent } from '../icons/comment-icon/comment-icon.component';
import { Comment, Tweet, TweetId } from '@core/models/tweet.interface';
import { TweetService } from '@shared/services/tweet.service';
import { LikeIconComponent } from '../icons/like-icon/like-icon.component';
import { RetweetIconComponent } from '../icons/retweet-icon/retweet-icon.component';
import { DatePipe, NgFor } from '@angular/common';
import { CommentPostComponent } from '../comment-post/comment-post.component';
import { CommentCardComponent } from '../comment-card/comment-card.component';

@Component({
  selector: 'tweet-card',
  standalone: true,
  imports: [
    CommentIconComponent,
    LikeIconComponent,
    RetweetIconComponent,
    DatePipe,
    CommentPostComponent,
    CommentCardComponent,
    NgFor,
  ],
  templateUrl: './tweet-card.component.html',
  styleUrl: './tweet-card.component.css',
})
export class TweetCardComponent {
  @Input() tweet: Tweet = {
    id: 1,
    content: 'Este es el contenido del tweet',
    author: 'usuario1',
    createdAt: '2024-02-20 14:30:00',
    retweets: [],
    comments: [],
    liked: false,
    retweeted: false,
    retweetsCount: 0,
    likesCount: 0,
    commentsCount: 0,
  };
  toast = false;
  commentVisible = true;

  constructor(private tweetService: TweetService) {}

  ngOnInit(): void {}

  // Maneja si el componente hijo (comment section) ha posteado un comentario
  // y activa el toast
  handleActiveToast(newValue: boolean) {
    if (newValue === true) {
      // Selecciona el elemento de la modal por su ID
      const toastElement = document.getElementById('toast');
      // Elimina la clase 'hidden' para hacer visible la modal
      toastElement!.classList.remove('hidden');
      toastElement!.classList.add('flex');

      setTimeout(() => {
        toastElement!.classList.remove('flex');
        toastElement!.classList.add('hidden');
      }, 3000);
    }
  }

  // Like or Dislike
  like(id: number) {
    const tweetId: TweetId = {
      tweetId: id,
    };

    const tweet = this.tweet;
    if (tweet) {
      tweet.liked = !tweet.liked;

      // Si antes no tenia un like y ahora lo tiene lo anadimos a la bbdd
      // Sino lo eliminamos
      if (tweet.liked) {
        this.tweetService.post(tweetId, '/api/like').subscribe((res) => {
          console.log(res);
        });
      } else {
        // Borrar el like de la base de datos
        this.tweetService
          .post(tweetId, '/api/delete/like')
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
    const tweet = this.tweet;
    if (tweet) {
      tweet.retweeted = !tweet.retweeted;

      // Si antes no tenia un retweet y ahora lo tiene lo anadimos a la bbdd
      // Sino lo eliminamos
      if (tweet.retweeted) {
        this.tweetService.post(tweetId, '/api/retweet').subscribe((res) => {
          console.log(res);
        });
      } else {
        // Borrar el retweet de la base de datos
        this.tweetService
          .post(tweetId, '/api/delete/retweet')
          .subscribe((res: any) => {
            console.log(res);
          });
      }
    }

    console.log('Estructura del tweetId: ' + tweet);
  }

  handleCommentClick = () => {
    this.commentVisible = !this.commentVisible;
  };
}
