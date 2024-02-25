import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'like-icon',
  standalone: true,
  imports: [],
  templateUrl: './like-icon.component.html',
  styleUrl: './like-icon.component.css',
})
export class LikeIconComponent implements OnInit {
  @Input() liked: boolean = false;

  ngOnInit(): void {}
}
