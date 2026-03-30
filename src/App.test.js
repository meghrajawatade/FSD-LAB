import { render, screen } from '@testing-library/react';
import App from './App';

test('renders the resume builder title', () => {
  render(<App />);
  expect(screen.getByRole('heading', { name: /elysian resume/i })).toBeInTheDocument();
});
