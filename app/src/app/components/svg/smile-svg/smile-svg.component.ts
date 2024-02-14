import { Component } from '@angular/core';
import { AncorWrapComponent } from '../ancor-wrap/ancor-wrap.component';

@Component({
  selector: 'app-smile-svg',
  standalone: true,
  imports: [AncorWrapComponent],
  templateUrl: './smile-svg.component.html',
  styleUrl: './smile-svg.component.css',
})
export class SmileSVGComponent {}
