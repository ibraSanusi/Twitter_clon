import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

@Component({
  selector: 'app-manager-page',
  standalone: true,
  imports: [],
  templateUrl: './manager-page.component.html',
  styleUrls: ['./manager-page.component.css'],
})
export class ManagerPageComponent implements OnInit {
  ngOnInit(): void {
    this.createChart();
  }

  createChart() {
    const myChart = new Chart('myChart', {
      type: 'bar',
      data: {
        labels: ['Enero', 'Febrero', 'Marzo'],
        datasets: [{ label: 'Ventas', data: [10, 20, 30] }],
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: 'Chart.js Bar Chart',
          },
        },
      },
    });
  }
}
