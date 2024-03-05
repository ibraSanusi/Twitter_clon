import { NgFor } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import {
  FollowingId,
  Tweet,
  TweetResponse,
} from '@core/models/tweet.interface';
import { IUser } from '@core/models/user.interface';
import { AuthService } from '@shared/services/auth.service';
import { FollowService } from '@shared/services/follow.service';
import { TweetService } from '@shared/services/tweet.service';

@Component({
  selector: 'user-recomendated-card',
  standalone: true,
  imports: [NgFor],
  templateUrl: './user-recomendated-card.component.html',
  styleUrl: './user-recomendated-card.component.css',
})
export class UserRecomendatedCardComponent implements OnInit {
  users: IUser[] = [];
  session: boolean = false;
  userSession: string = '';
  tweets: Tweet[] = [];

  constructor(
    private http: HttpClient,
    private followingService: FollowService,
    private authService: AuthService
  ) {}

  ngOnInit(): void {
    // Verifica la sesión utilizando el servicio de autenticación
    this.authService.checkSession('/anonymous/checkSession').subscribe(
      (session) => {
        console.log('Session: ' + session);
        this.session = session;
        if (session) {
          this.getRecomendatedUsers();
        }
      },
      (error) => {
        console.error('Error al verificar la sesión:', error);
      }
    );
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
