import { TestBed } from '@angular/core/testing';

import { TweetGlobalService } from './tweetGlobal.service';

describe('GlobalService', () => {
  let service: TweetGlobalService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(TweetGlobalService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
