import { Component } from '@angular/core';
import { AncorWrapComponent } from '../ancor-wrap/ancor-wrap.component';

@Component({
  selector: 'app-image-svg',
  standalone: true,
  imports: [AncorWrapComponent],
  templateUrl: './image-svg.component.html',
  styleUrl: './image-svg.component.css',
})
export class ImageSVGComponent {}
