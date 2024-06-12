import { ApolloClient, InMemoryCache, HttpLink } from "@apollo/client";

const client = new ApolloClient({
  link: new HttpLink({
    uri: "http://localhost/scandiweb/scandiweb-backend/public/index.php/graphql",
  }),
  cache: new InMemoryCache(),
});

export default client;
