export interface LoginUser {
  username: string;
  password: string;
  roles: string[];
}

export interface IUser {
  id: number;
  username: string;
  roles: string[];
  followed: boolean;
}

export interface UserRanking {
  id: number;
  username: string;
  followersCount: number;
}
