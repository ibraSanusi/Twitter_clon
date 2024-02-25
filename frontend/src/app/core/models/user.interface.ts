export interface LoginUser {
  username: string;
  password: string;
}

export interface IUser {
  id: number;
  username: string;
  roles: string[];
  followed: boolean;
}
