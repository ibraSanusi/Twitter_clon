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
  {
    path: 'manager',
    loadChildren: () =>
      import('./modules/manager/manager.module').then((m) => m.ManagerModule),
  },
  {
    path: 'register',
    loadChildren: () =>
      import('./modules/register/register.module').then(
        (m) => m.RegisterModule
      ),
  },
  {
    path: 'accesibility',
    loadChildren: () =>
      import('./modules/accesibility/accesibility.module').then(
        (m) => m.AccesibilityModule
      ),
  },
  // Otras rutas de tu aplicación
  { path: '', redirectTo: 'home', pathMatch: 'full' }, // Redirigir a '/home' si no se ha especificado ninguna otra ruta
  { path: '**', redirectTo: 'home' }, // Redirigir a '/home' si la ruta especificada no coincide con ninguna otra ruta definida
];
