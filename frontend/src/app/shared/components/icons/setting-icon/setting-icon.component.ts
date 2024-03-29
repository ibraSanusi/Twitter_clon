import { Component, Input } from '@angular/core';

@Component({
  selector: 'setting-icon',
  standalone: true,
  imports: [],
  templateUrl: './setting-icon.component.html',
  styleUrl: './setting-icon.component.css',
})
export class SettingIconComponent {
  @Input() size: number = 0;
}
