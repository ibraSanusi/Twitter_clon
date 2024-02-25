import {
  Component,
  ElementRef,
  EventEmitter,
  Input,
  Output,
  ViewChild,
  AfterViewInit,
} from '@angular/core';
import { CommentContent, TweetId } from '@core/models/tweet.interface';
import { TweetService } from '@shared/services/tweet.service';
import { ImageIconComponent } from '../icons/image-icon/image-icon.component';
import { GifIconComponent } from '../icons/gif-icon/gif-icon.component';
import { SmileIconComponent } from '../icons/smile-icon/smile-icon.component';
import { StatsIconComponent } from '../icons/stats-icon/stats-icon.component';

@Component({
  selector: 'comment-post',
  standalone: true,
  imports: [],
  templateUrl: './comment-post.component.html',
  styleUrls: ['./comment-post.component.css'],
})
export class CommentPostComponent implements AfterViewInit {
  @ViewChild('post-comment') textarea!: ElementRef;
  @Input() tweetId: number = 0;
  @Output() toast = new EventEmitter<boolean>();

  constructor(private tweetService: TweetService) {}

  ngAfterViewInit() {
    this.adjustTextareaHeight();
  }

  adjustTextareaHeight() {
    const textarea = this.textarea.nativeElement;
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 2 + 'px'; // Agrega un pequeño espacio adicional
  }

  // Comentar
  comment() {
    const textarea = this.textarea.nativeElement;
    const content = textarea.value.trim();

    const comment: CommentContent = {
      tweetId: this.tweetId,
      content: content,
    };

    this.tweetService.post(comment, '/api/comment').subscribe((res) => {
      console.log(res);
      textarea.value = '';
      // Emitir el cambio deseado al componente padre
      // TODO: Comprobar si se ha publicado correctamente
      this.toast.emit(true);
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
}
