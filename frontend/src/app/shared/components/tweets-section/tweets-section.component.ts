import { Component, Input, OnInit } from '@angular/core';
import { TweetCardComponent } from '../tweet-card/tweet-card.component';
import { TweetService } from '@shared/services/tweet.service';
import { Tweet, TweetResponse } from '@core/models/tweet.interface';
import { NgFor } from '@angular/common';
import { PostSectionComponent } from '../post-section/post-section.component';

@Component({
  selector: 'tweets-section',
  standalone: true,
  imports: [TweetCardComponent, NgFor, PostSectionComponent],
  templateUrl: './tweets-section.component.html',
  styleUrl: './tweets-section.component.css',
})
export class TweetsSectionComponent {
  @Input() tweets: Tweet[] = [];
}
