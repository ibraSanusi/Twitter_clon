import { Component, Input } from '@angular/core';

@Component({
  selector: 'search-icon',
  standalone: true,
  imports: [],
  templateUrl: './search-icon.component.html',
  styleUrl: './search-icon.component.css',
})
export class SearchIconComponent {
  @Input() size: number = 0;
}
