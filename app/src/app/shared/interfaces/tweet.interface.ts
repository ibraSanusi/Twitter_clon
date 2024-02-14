export interface TweetResponse {
  success: boolean;
  data: Tweet[];
}

export interface Tweet {
  id: number;
  content: string;
  publish_date: string;
  author: string;
}
