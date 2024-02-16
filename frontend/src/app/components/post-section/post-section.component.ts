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
    // const tweet: TweetContent = {
    //   content: 'Primer tweet desde angular.',
    // };
    const textarea = this.postTextarea.nativeElement;
    const tweet: TweetContent = {
      content: textarea.value,
    };

    // console.log(tweet);

    this.tweetService.postTweet(tweet, 'api/post/tweet').subscribe((res) => {
      console.log(res);
    });
  }
}
