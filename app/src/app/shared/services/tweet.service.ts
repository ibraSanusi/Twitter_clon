import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { IUser } from '../interfaces/user.interface';
import { Observable } from 'rxjs';
<<<<<<< HEAD
=======
import { TweetResponse } from '../interfaces/tweet.interface';
>>>>>>> 03b74d4

@Injectable({
  providedIn: 'root',
})
export class TweetService {
  private apiUrl = 'http://127.0.0.1:8000/';

  constructor(private http: HttpClient) {}

  getTweets(path: string): Observable<any> {
<<<<<<< HEAD
    return this.http.get<IUser>(`${this.apiUrl}${path}`, {
=======
    return this.http.get<TweetResponse>(`${this.apiUrl}${path}`, {
>>>>>>> 03b74d4
      withCredentials: true,
    });
  }
}
