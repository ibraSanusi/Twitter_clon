import {
  Component,
  ElementRef,
  EventEmitter,
  Output,
  ViewChild,
} from '@angular/core';
import {
  Tweet,
  TweetContent,
  TweetResponse,
} from '@core/models/tweet.interface';
import { TweetService } from '@shared/services/tweet.service';
import { ImageIconComponent } from '../icons/image-icon/image-icon.component';
import { GifIconComponent } from '../icons/gif-icon/gif-icon.component';
import { SmileIconComponent } from '../icons/smile-icon/smile-icon.component';
import { StatsIconComponent } from '../icons/stats-icon/stats-icon.component';

@Component({
  selector: 'post-section',
  standalone: true,
  imports: [
    ImageIconComponent,
    GifIconComponent,
    SmileIconComponent,
    StatsIconComponent,
  ],
  templateUrl: './post-section.component.html',
  styleUrls: ['./post-section.component.css'],
})
export class PostSectionComponent {
  @ViewChild('postTextarea') postTextarea!: ElementRef;
  @Output() postedTweet = new EventEmitter<Tweet>();

  constructor(private tweetService: TweetService) {}

  onInput() {
    this.adjustTextareaHeight();
  }

  adjustTextareaHeight() {
    const textarea = this.postTextarea.nativeElement;
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 2 + 'px'; // Agrega un pequeño espacio adicional
  }

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
      this.postedTweet.emit(res);
    });
  }
}
