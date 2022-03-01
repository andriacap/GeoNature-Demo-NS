import { Injectable } from '@angular/core';
import { MatSidenav } from '@angular/material/sidenav';
import { Subject } from 'rxjs';

@Injectable()
export class SideNavService {
  sidenav: MatSidenav;
  opened: boolean;
  private _module = new Subject<any>();
  public currentModule: any;
  gettingCurrentModule = this._module.asObservable();
  // List of the apps
  public modules: Array<any>;
  public home_page;
  public exportModule;

  constructor() {
    this.opened = false;
  }

  setSideNav(sidenav: MatSidenav) {
    this.sidenav = sidenav;
  }

  setHome(sidenav: MatSidenav) {
    sidenav.open();
  }

  setCurrentApp(app): any {
    this.currentModule = app;
    this._module.next(app);
  }

  getCurrentApp() {
    return this.currentModule;
  }

  getHomeItem() {
    return { module_url: '/', module_label: 'Accueil', module_picto: 'fa-home', id: '1' };
  }

  toggleSideNav() {
    this.sidenav.toggle();
  }
}
