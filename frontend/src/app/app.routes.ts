import { Routes } from '@angular/router';

export const routes: Routes = [
  //TODO: router-outlet (Padre)
  {
    path: 'auth', //TODO: (public) Login, Register, Forgot...
    loadChildren: () =>
      import('./modules/auth/auth.module').then((m) => m.AuthModule),
  },
  {
    path: 'home', //TODO: (public) Login, Register, Forgot...
    loadChildren: () =>
      import('./modules/home/home.module').then((m) => m.HomeModule),
  },
];
