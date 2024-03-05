import { DatePipe, NgFor, NgIf } from '@angular/common';
import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import {
  Comment,
  CommentContent,
  Like,
  LikeComment,
  Retweet,
  RetweetComment,
  Tweet,
  TweetContent,
  TweetId,
  TweetResponse,
} from '@core/models/tweet.interface';
import { CommentIconComponent } from '@shared/components/icons/comment-icon/comment-icon.component';
import { GifIconComponent } from '@shared/components/icons/gif-icon/gif-icon.component';
import { ImageIconComponent } from '@shared/components/icons/image-icon/image-icon.component';
import { LikeIconComponent } from '@shared/components/icons/like-icon/like-icon.component';
import { ProfileIconComponent } from '@shared/components/icons/profile-icon/profile-icon.component';
import { RetweetIconComponent } from '@shared/components/icons/retweet-icon/retweet-icon.component';
import { SearchIconComponent } from '@shared/components/icons/search-icon/search-icon.component';
import { SettingIconComponent } from '@shared/components/icons/setting-icon/setting-icon.component';
import { SmileIconComponent } from '@shared/components/icons/smile-icon/smile-icon.component';
import { StarIconComponent } from '@shared/components/icons/star-icon/star-icon.component';
import { StatsIconComponent } from '@shared/components/icons/stats-icon/stats-icon.component';
import { MenuBarComponent } from '@shared/components/menu-bar/menu-bar.component';
import { PostSectionComponent } from '@shared/components/post-section/post-section.component';
import { TweetsSectionComponent } from '@shared/components/tweets-section/tweets-section.component';
import { UserRecomendatedCardComponent } from '@shared/components/user-recomendated-card/user-recomendated-card.component';
import { AuthService } from '@shared/services/auth.service';
import { TweetService } from '@shared/services/tweet.service';

@Component({
  selector: 'home-page',
  standalone: true,
  imports: [
    MenuBarComponent,
    TweetsSectionComponent,
    PostSectionComponent,
    SearchIconComponent,
    ProfileIconComponent,
    StarIconComponent,
    SettingIconComponent,
    ImageIconComponent,
    GifIconComponent,
    SmileIconComponent,
    StatsIconComponent,
    CommentIconComponent,
    LikeIconComponent,
    RetweetIconComponent,
    NgFor,
    DatePipe,
    NgIf,
    UserRecomendatedCardComponent,
    RouterLink,
  ],
  templateUrl: './home-page.component.html',
  styleUrl: './home-page.component.css',
})
export class HomePageComponent implements OnInit {
  userSession: string = '';
  tweets: Tweet[] = [];
  canComment: number = 0;
  session: boolean = true;
  // Declaración de la variable en el componente
  tweetCommentVisibility: { [key: number]: boolean } = {};
  @ViewChild('commentTextarea') commentPostarea!: ElementRef;
  @ViewChild('postTextarea') postTextarea!: ElementRef;

  constructor(
    private tweetService: TweetService,
    private router: Router,
    private authService: AuthService
  ) {}

  ngOnInit(): void {
    // Verifica la sesión utilizando el servicio de autenticación
    this.authService.checkSession('/anonymous/checkSession').subscribe(
      (session) => {
        console.log('Session: ' + session);
        this.session = session;
        if (session) {
          this.getFollowingTweets();
        } else {
          this.getAllTweets();
        }
      },
      (error) => {
        console.error('Error al verificar la sesión:', error);
      }
    );
  }

  getAllTweets() {
    this.tweetService.get('/showalltweets').subscribe((res: TweetResponse) => {
      this.userSession = res.userSession;
      this.tweets = res.data;
      console.log(res.data);
    });
  }

  // Recupera los tweets de los seguidos
  private getFollowingTweets() {
    this.tweetService
      .get('/api/following/tweets')
      .subscribe((res: TweetResponse) => {
        this.userSession = res.userSession;
        this.tweets = res.data;
        console.log(res.data);
      });
  }

  /// TODO: Cerrar sesion, pero no funciona bien por el momento
  logout() {
    this.authService.logout('/api/logout').subscribe((res) => {
      console.log('Se cerro sesion correctamente: ' + res);
      console.log(document.cookie.valueOf());
      // window.location.reload();
    });
  }

  // Postear un tweet
  postTweet() {
    const textarea = this.postTextarea.nativeElement;
    const tweetContent = textarea.value.trim();

    // Verificar si el contenido del tweet está vacío o nulo
    if (!tweetContent) {
      console.log('El contenido del tweet está vacío');
      return; // No hagas nada si el contenido del tweet está vacío
    }

    const tweet: TweetContent = {
      content: tweetContent,
    };

    // Realizar la publicación del tweet
    this.tweetService.post(tweet, '/api/post/tweet').subscribe((res: Tweet) => {
      console.log(res);
      textarea.value = ''; // Limpiar el contenido del textarea después de publicar el tweet
    });
  }

  // Ejecuta la autoredimensiion del textarea de los posts
  onInput() {
    this.adjustTextareaHeight();
  }

  // Reajusta el tamano del text area cuando se anade una fila mas
  adjustTextareaHeight() {
    const textarea = this.postTextarea.nativeElement;
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 2 + 'px'; // Agrega un pequeño espacio adicional
  }

  // Comentar un tweet
  comment(tweetId: number) {
    const textarea = this.commentPostarea.nativeElement;
    const contentContent: string = textarea.value.trim();

    // Verificar si el contenido del tweet está vacío o nulo
    if (!contentContent) {
      console.log('El contenido del comentario está vacío');
      return; // No hagas nada si el contenido del tweet está vacío
    }

    const comment: CommentContent = {
      tweetId: tweetId,
      content: contentContent,
    };

    this.tweetService
      .post(comment, '/api/comment')
      .subscribe((res: Comment) => {
        console.log(res);
        textarea.value = '';
        this.tweets.find((tweet) => tweet.id === tweetId)?.comments.push(res);
      });
  }

  // Eliminar comentario
  removeComment(id: number) {
    const tweetId: TweetId = {
      tweetId: id,
    };
    // Borrar el comentario de la base de datos
    this.tweetService
      .post(tweetId, '/api/delete/comment')
      .subscribe((res: any) => {
        console.log(res);
      });
  }

  // Función para mostrar u ocultar los comentarios de un tweet específico
  toggleCommentVisibility(tweetId: number) {
    this.tweetCommentVisibility[tweetId] =
      !this.tweetCommentVisibility[tweetId];
  }

  // Dar like o unlike a un tweet
  likeComment(tweetId: number, commentId: number) {
    const likeComment: LikeComment = {
      commentId: commentId,
    };

    const tweet = this.tweets.find((tweet) => tweet.id === tweetId);
    if (tweet) {
      const comment = tweet.comments.find(
        (comment) => comment.id === commentId
      );
      if (comment) {
        if (!comment.liked) {
          this.tweetService
            .post(likeComment, '/api/like/comment')
            .subscribe((res: Comment) => {
              console.log(res);
            });
          comment.likesCount += 1;
        } else {
          this.tweetService
            .post(likeComment, '/api/delete/comment/like')
            .subscribe((res: Comment) => {
              console.log(res);
            });
          comment.likesCount -= 1;
        }
        comment.liked = !comment.liked;
      }
    }
  }

  // Dar retweet o quitarselo a un tweet
  retweetComment(tweetId: number, commentId: number) {
    const retweetComment: RetweetComment = {
      commentId: commentId,
    };

    const tweet = this.tweets.find((tweet) => tweet.id === tweetId);
    if (tweet) {
      const comment = tweet.comments.find(
        (comment) => comment.id === commentId
      );
      if (comment) {
        if (!comment.retweeted) {
          this.tweetService
            .post(retweetComment, '/api/retweet/comment')
            .subscribe((res: Comment) => {
              console.log(res);
            });
          comment.retweetsCount += 1;
        } else {
          this.tweetService
            .post(retweetComment, '/api/delete/retweet/comment')
            .subscribe((res: Comment) => {
              console.log(res);
            });

          comment.retweetsCount -= 1;
        }
        comment.retweeted = !comment.retweeted;
      }
    }
  }

  // Dar like a un tweet o eliminarlo
  like(tweetId: number) {
    const like: Like = {
      tweetId: tweetId,
    };

    const tweet = this.tweets.find((tweet) => tweet.id === tweetId);

    if (!tweet) return;

    let url = '';
    let quantity = 0;

    if (!tweet.liked) {
      url = '/api/like';
      quantity = 1;
    } else {
      url = '/api/delete/like';
      quantity = -1;
    }

    this.tweetService.post(like, url).subscribe((res) => {
      tweet.likesCount += quantity;
      tweet.liked = !tweet.liked;
    });
  }

  // Dar retweet a un tweet o eliminarlo
  retweet(tweetId: number) {
    const retweet: {
      tweetId: number;
    } = {
      tweetId: tweetId,
    };

    const tweet = this.tweets.find((tweet) => tweet.id === tweetId);

    if (!tweet) return;

    let url = '';
    let quantity = 0;

    if (!tweet.retweeted) {
      url = '/api/retweet';
      quantity = 1;
    } else {
      url = '/api/delete/retweet';
      quantity = -1;
    }

    this.tweetService.post(retweet, url).subscribe((res) => {
      tweet.retweetsCount += quantity;
      console.log(tweet.retweetsCount);
      tweet.retweeted = !tweet.retweeted;
    });
  }
}
