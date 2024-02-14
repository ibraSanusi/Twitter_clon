import { Component } from '@angular/core';
import { AncorWrapComponent } from '../ancor-wrap/ancor-wrap.component';

@Component({
  selector: 'app-stats-svg',
  standalone: true,
  imports: [AncorWrapComponent],
  templateUrl: './stats-svg.component.html',
  styleUrl: './stats-svg.component.css',
})
export class StatsSVGComponent {}
