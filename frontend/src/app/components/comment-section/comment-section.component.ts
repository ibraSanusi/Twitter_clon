import {
  Component,
  ElementRef,
  EventEmitter,
  Input,
  Output,
  ViewChild,
} from '@angular/core';
import {
  Comment,
  Tweet,
  TweetId,
} from '../../shared/interfaces/tweet.interface';
import { TweetService } from '../../shared/services/tweet.service';

@Component({
  selector: 'app-comment-section',
  templateUrl: './comment-section.component.html',
  styleUrl: './comment-section.component.css',
})
export class CommentSectionComponent {
  @ViewChild('postTextarea') postTextarea!: ElementRef;
  @Input() tweetId: number = 0;
  @Output() toast = new EventEmitter<boolean>();

  constructor(private tweetService: TweetService) {}

  onInput() {
    this.adjustTextareaHeight();
  }

  adjustTextareaHeight() {
    const textarea = this.postTextarea.nativeElement;
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 2 + 'px'; // Agrega un pequeño espacio adicional
  }

  // Comentar
  comment(tweetId: number) {
    const textarea = this.postTextarea.nativeElement;
    const content = textarea.value.trim();

    const comment: Comment = {
      tweetId: tweetId,
      content: content,
    };

    this.tweetService.post(comment, 'api/comment').subscribe((res) => {
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
      .post(tweetId, 'api/delete/comment')
      .subscribe((res: any) => {
        console.log(res);
      });
  }
}
