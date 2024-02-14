import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RetweetIconComponent } from './retweet-icon.component';

describe('RetweetIconComponent', () => {
  let component: RetweetIconComponent;
  let fixture: ComponentFixture<RetweetIconComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [RetweetIconComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(RetweetIconComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
