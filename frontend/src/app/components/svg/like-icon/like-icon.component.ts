import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-like-icon',
  templateUrl: './like-icon.component.html',
  styleUrl: './like-icon.component.css',
})
export class LikeIconComponent implements OnInit {
  @Input() liked: boolean = false;

  ngOnInit(): void {}
}
