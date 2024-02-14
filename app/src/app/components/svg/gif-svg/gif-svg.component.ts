import { Component } from '@angular/core';
import { AncorWrapComponent } from '../ancor-wrap/ancor-wrap.component';

@Component({
  selector: 'app-gif-svg',
  standalone: true,
  imports: [AncorWrapComponent],
  templateUrl: './gif-svg.component.html',
  styleUrl: './gif-svg.component.css',
})
export class GifSVGComponent {}
