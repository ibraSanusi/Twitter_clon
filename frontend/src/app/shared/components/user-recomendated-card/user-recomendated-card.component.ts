import { NgFor } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { FollowingId } from '@core/models/tweet.interface';
import { IUser } from '@core/models/user.interface';
import { FollowService } from '@shared/services/follow.service';

@Component({
  selector: 'user-recomendated-card',
  standalone: true,
  imports: [NgFor],
  templateUrl: './user-recomendated-card.component.html',
  styleUrl: './user-recomendated-card.component.css',
})
export class UserRecomendatedCardComponent implements OnInit {
  users: IUser[] = [];

  constructor(
    private http: HttpClient,
    private followingService: FollowService
  ) {}

  ngOnInit(): void {
    this.getRecomendatedUsers();
  }

  // Recupera los usuarios a los que no sigue el usuario en sesion
  getRecomendatedUsers() {
    this.followingService
      .get('/api/recomendated/users')
      .subscribe((res: IUser[]) => {
        console.log(res);
        this.users = res;
      });
  }

  follow(followingId: number) {
    const followingBody: FollowingId = {
      followingId: followingId,
    };

    // Seguir o dejar de seguir un usuario
    const user = this.users.find((user) => user.id === followingId);
    if (!user) return;

    if (!user.followed) {
      this.followingService
        .post(followingBody, '/api/follow')
        .subscribe((res) => {
          console.log(res);
          user.followed = !user.followed;
        });
    } else {
      this.followingService
        .post(followingBody, '/api/unfollow')
        .subscribe((res) => {
          console.log(res);
          user.followed = !user.followed;
        });
    }
  }
}
