import { DatePipe, NgIf } from '@angular/common';
import { Component, Input, OnInit } from '@angular/core';
import { Comment } from '@core/models/tweet.interface';
import { TweetService } from '@shared/services/tweet.service';

@Component({
  selector: 'comment-card',
  standalone: true,
  imports: [DatePipe, NgIf],
  templateUrl: './comment-card.component.html',
  styleUrl: './comment-card.component.css',
})
export class CommentCardComponent implements OnInit {
  @Input() comment: Comment = {
    id: 0,
    author: '',
    content: '',
    liked: false,
    retweeted: false,
    parentComment: undefined,
    likesCount: 0,
    commentsCount: 0,
    retweetsCount: 0,
    createdAt: '',
  };

  dropDown: boolean = false;

  constructor(private tweetService: TweetService) {}

  ngOnInit(): void {}

  // Like or Dislike
  like(id: number) {}

  // Retweetear o Desretweetear
  retweet(id: number) {}

  // Desplegar las opciones del comentario
  handleDropDown = () => {
    this.dropDown = !this.dropDown;
  };
}
