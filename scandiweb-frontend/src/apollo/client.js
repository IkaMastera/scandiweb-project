import { ApolloClient, InMemoryCache } from "@apollo/client";

const client = new ApolloClient({
  uri: "http://localhost/scandiweb-backend/public/index.php/graphql", // Adjust this URL to your backend deployment URL
  cache: new InMemoryCache(),
});

export default client;
