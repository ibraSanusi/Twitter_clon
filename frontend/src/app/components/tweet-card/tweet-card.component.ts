import { Component, Input } from '@angular/core';
import { TweetService } from '../../shared/services/tweet.service';
import { Tweet, TweetId } from '../../shared/interfaces/tweet.interface';

@Component({
  selector: 'app-tweet-card',
  templateUrl: './tweet-card.component.html',
  styleUrls: ['./tweet-card.component.css'],
})
export class TweetCardComponent {
  @Input() tweets: Tweet[] = [];
  toast = false;

  constructor(private tweetService: TweetService) {}

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

  // Abrir la modal
  openModal() {
    // Selecciona el elemento de la modal por su ID
    const modal = document.getElementById('comment-modal');
    // Elimina la clase 'hidden' para hacer visible la modal
    modal!.classList.remove('hidden');
    modal!.classList.add('flex');
  }

  // Cerrar la modal
  closeModal() {
    // Selecciona el elemento de la modal por su ID
    const modal = document.getElementById('comment-modal');
    // Elimina la clase 'hidden' para hacer visible la modal
    modal!.classList.add('hidden');
    modal!.classList.remove('flex');
  }
}
