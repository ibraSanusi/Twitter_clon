import { Component, ElementRef, ViewChild } from '@angular/core';

@Component({
  selector: 'app-post-section',
  templateUrl: './post-section.component.html',
  styleUrls: ['./post-section.component.css'],
})
export class PostSectionComponent {
  @ViewChild('postTextarea') postTextarea!: ElementRef;

  onInput() {
    this.adjustTextareaHeight();
  }

  adjustTextareaHeight() {
    const textarea = this.postTextarea.nativeElement;
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 2 + 'px'; // Agrega un pequeño espacio adicional
  }
}
