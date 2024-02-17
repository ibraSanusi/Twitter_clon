export interface TweetResponse {
  success: boolean;
  data: Tweet[];
}

export interface Tweet {
  id: number;
  content: string;
  author: string;
  publishDate: string;
  retweets: Retweet[];
  liked: boolean;
  retweeted: boolean;
  likesCount: number;
}

export interface Retweet {
  id: number;
  tweet: number;
  retweetDate: RetweetDate;
  userId: number;
}

export interface RetweetDate {
  date: string;
  timezone_type: number;
  timezone: string;
}

export interface TweetContent {
  content: string;
}

export interface TweetId {
  tweetId: number;
}
