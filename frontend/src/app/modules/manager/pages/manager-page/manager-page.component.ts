import { Component, OnInit } from '@angular/core';
import { UserRanking } from '@core/models/user.interface';
import { ManagerService } from '@modules/manager/services/manager.service';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

@Component({
  selector: 'app-manager-page',
  templateUrl: './manager-page.component.html',
  styleUrls: ['./manager-page.component.css'],
})
export class ManagerPageComponent implements OnInit {
  users: UserRanking[] = [];

  constructor(private http: ManagerService) {}

  ngOnInit(): void {
    this.getTopRanking();
  }

  getTopRanking(): void {
    this.http.get('/api/most/followed').subscribe((users: UserRanking[]) => {
      // Ordenar los usuarios por followersCount de forma descendente
      const orderedUsers: UserRanking[] = users.sort(
        (a, b) => b.followersCount - a.followersCount
      );
      this.users = orderedUsers;

      this.createChart(orderedUsers);
    });
  }

  createChart(users: UserRanking[]): void {
    const labels: string[] = [];
    const followersCount: number[] = [];

    users.forEach((user) => {
      labels.push(user.username);
      followersCount.push(user.followersCount);
    });

    const myChart = new Chart('myChart', {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{ label: 'Followers Count', data: followersCount }],
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: 'Top 5 Users by Followers Count',
          },
        },
      },
    });
  }
}
