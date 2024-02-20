import { Component, Input, OnInit } from '@angular/core';
import {
  Comment,
  Tweet,
  TweetId,
  TweetResponse,
} from '../../shared/interfaces/tweet.interface';
import { TweetService } from '../../shared/services/tweet.service';
import { TweetGlobalService } from '../../shared/global/tweetGlobal.service';

@Component({
  selector: 'app-comment-card',
  templateUrl: './comment-card.component.html',
  styleUrl: './comment-card.component.css',
})
export class CommentCardComponent implements OnInit {
  @Input() comment: Comment = {
    id: 0,
    author: '',
    content: '',
    parentComment: 0,
    createdAt: '',
  };

  constructor(private tweetService: TweetService) {}

  ngOnInit(): void {}

  // Like or Dislike
  like(id: number) {}

  // Retweetear o Desretweetear
  retweet(id: number) {}
}
