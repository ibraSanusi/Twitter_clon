import { Component, ElementRef, ViewChild } from '@angular/core';
import { TweetService } from '../../shared/services/tweet.service';
import { Tweet, TweetContent } from '../../shared/interfaces/tweet.interface';

@Component({
  selector: 'app-post-section',
  templateUrl: './post-section.component.html',
  styleUrls: ['./post-section.component.css'],
})
export class PostSectionComponent {
  @ViewChild('postTextarea') postTextarea!: ElementRef;

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
    this.tweetService.post(tweet, 'api/post/tweet').subscribe((res) => {
      console.log(res);
      textarea.value = ''; // Limpiar el contenido del textarea después de publicar el tweet
    });
  }
}
