import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-retweet-icon',
  templateUrl: './retweet-icon.component.html',
  styleUrl: './retweet-icon.component.css',
})
export class RetweetIconComponent implements OnInit {
  @Input() retweeted: boolean = false;

  ngOnInit(): void {}
}
