import { Component, Input } from '@angular/core';

@Component({
  selector: 'profile-icon',
  standalone: true,
  imports: [],
  templateUrl: './profile-icon.component.html',
  styleUrl: './profile-icon.component.css',
})
export class ProfileIconComponent {
  @Input() size: number = 0;
}
