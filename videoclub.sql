-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 14, 2023 at 11:24 PM
-- Server version: 5.7.34
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `videoclub`
--

-- --------------------------------------------------------

--
-- Table structure for table `aluguer`
--

CREATE TABLE `aluguer` (
  `id` int(11) NOT NULL,
  `movieId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aluguer`
--

INSERT INTO `aluguer` (`id`, `movieId`, `userId`, `date`, `active`) VALUES
(4, 1, 4, '2023-01-09 11:23:17', 1),
(5, 12, 4, '2023-01-09 11:26:57', 0),
(6, 11, 4, '2023-01-09 11:26:59', 0),
(7, 7, 4, '2023-01-09 11:27:01', 0),
(8, 3, 4, '2023-01-09 11:30:48', 0),
(9, 10, 1, '2023-01-09 18:04:59', 1),
(10, 4, 1, '2023-01-09 18:05:12', 1),
(11, 2, 1, '2023-01-09 18:24:30', 1),
(12, 15, 1, '2023-01-09 18:24:44', 0),
(13, 2, 3, '2023-01-10 14:56:02', 0),
(14, 16, 7, '2023-01-12 11:12:20', 0),
(15, 14, 2, '2023-01-13 23:16:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `releaseDate` varchar(25) NOT NULL,
  `rating` varchar(10) NOT NULL,
  `cast` varchar(1000) NOT NULL,
  `producer` varchar(255) NOT NULL,
  `genres` varchar(255) NOT NULL,
  `rented` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`id`, `title`, `image`, `description`, `releaseDate`, `rating`, `cast`, `producer`, `genres`, `rented`) VALUES
(1, 'Spider-Man: No Way Home', 'IMG-63a8daf841a6d9.55750609.jpg', 'Uma semana após os ataques de Quentin Beck na Europa, um vídeo é lançado no qual Beck culpa o Homem-Aranha por seu assassinato e revela a identidade do Homem-Aranha como Peter Parker. Peter e MJ fogem para seu apartamento, reunindo-se com sua tia May e Happy Hogan. Peter, MJ, May e Ned Leeds são posteriormente detidos e interrogados, mas têm suas acusações retiradas com a ajuda do advogado Matt Murdock. Peter, MJ e Ned voltam ao colégio, mas suas inscrições para a universidade são rejeitadas devido à recente polêmica.', '2021', '4.8', 'Tom Holland, Tobey Maguire, Zendaya, Andrew Garfield, Marisa Tomei, Jacob Batalon', 'Marvel Studios', 'Ação, Comédia, Aventura', 0),
(2, 'As Cinquenta Sombras Mais Negras', 'IMG-63bb30a65e2a87.56175219.jpg', 'Incomodada com os hábitos e atitudes de Christian Grey (Jamie Dornan), Anastasia (Dakota Johnson) decide terminar o relacionamento e focar no desenvolvimento de sua carreira. O desejo, porém, fala mais alto e ela logo volta aos joguinhos do empresário, sendo que, aos poucos, passa a compreender melhor os jogos sexuais que ele tanto aprecia.', '2017', '4.6', 'Jamie Dornan, Dakota Johnson, Kim Basinger', 'Universal Pictures', 'Drama, Erótico', 1),
(3, 'Velocidade Furiosa 8', 'IMG-63c338df524f42.99251464.jpg', 'Agora que Dom e Letty estão em lua-de-mel, e Brian e Mia afastaram-se e o resto do grupo foi exonerado, a equipa que corre o mundo encontrou algo semelhante a uma vida normal. Porém, quando uma misteriosa mulher seduz Dom para o mundo do crime, do qual parece não ser capaz de escapar, ele acaba por trair aqueles lhe são mais próximos. A nossa força de elite vai atravessar o mundo para impedir que um anarquista lance o caos no cenário mundial…', '2017', '4.2', 'Vin Diesel, Dwayne Johnson, Jason Statham, Michelle Rodriguez', 'Universal Pictures', 'Ação, Aventura, Crime', 1),
(4, 'Joker', 'IMG-63bb32db253f60.89492317.jpg', 'Arthur Fleck é um homem que enfrenta a crueldade e o desprezo da sociedade, juntamente com a indiferença de um sistema que lhe permite passar da vulnerabilidade para a depravação. Durante o dia é um palhaço e à noite luta para se tornar um artista de stand-up comedy…mas descobre que é ele próprio a piada. Sempre diferente de todos em seu redor, o seu riso incontrolável e inapropriado, ganha ainda mais força quando tenta contê-lo, expondo-o a situações ridículas e até à violência...', '2019', '4.2', 'Joaquin Phoenix, Robert de Niro, Zazie Beetz, Glenn Feshler', 'Warner Bros, Pictures', 'Crime, Drama, Thriller', 0),
(5, 'Pantera Negra', 'IMG-63bb3453353686.05794494.jpg', 'Conheça a história de T&#039;Challa, príncipe do reino de Wakanda, que perde o seu pai e viaja para os Estados Unidos, onde tem contato com os Vingadores. Entre as suas habilidades estão a velocidade, inteligência e os sentidos apurados.', '2018', '3.9', 'Chadwick Boseman, Michael B. Jordan, Lupita Nyong&#039;o, Letita Wrigth', 'Marvel Studios', 'Ação, Aventura, Ficção Científica', 0),
(6, 'Baywatch: Marés Vivas', 'IMG-63bb36074fd1c2.55185910.jpg', 'Mitch Buchanan, é um nadador-salvador muito sério e responsável. É então forçado a trabalhar com Matt Brody, um jovem rebelde que não respeita as regras, para acabar com o plano de uma magnata do petróleo, a malvada Victoria Leeds.', '2017', '3.1', 'Dwayen Johnson, Zac Efron, Kelly Rohrbach, Alexandra Daddario', 'Paramount Pictures', 'Ação, Comédia, Drama', 0),
(7, 'Bad Boys Para Sempre', 'IMG-63bb36d04492b9.74242487.jpg', 'Os Bad Boys Mike Lowrey e Marcus Burnett estão de volta juntos para um último passeio no tão esperado Bad Boys for Life.', '2020', '3.8', 'Will Smith, Michael Bay, Vanessa Hudgens', 'Columbia Pictures', 'Ação, Comédia, Crime', 1),
(8, '1917', 'IMG-63bb37a58dc1b8.56238807.jpg', 'No auge da Primeira Guerra Mundial, dois jovens soldados britânicos, Schofield (George MacKay) e Blake (Dean-Charles Chapman), recebem uma missão aparentemente impossível. Numa corrida contra o tempo, têm de atravessar território inimigo e entregar uma mensagem que impedirá um ataque letal contra centenas de soldados, entre eles o irmão de Blake.', '2019', '4.6', 'George Mackay, Dean-Charles Chapman, Richard Madden, Andrew Scott', 'DreamWorks Pictures', 'Guerra, Drama', 0),
(9, 'Creed II', 'IMG-63bb383ee3e852.52517948.jpg', 'Adonis Creed (Michael B. Jordan) saiu mais forte do que nunca de sua luta contra &#039;Pretty&#039; Ricky Conlan (Tony Bellew), e segue sua trajetória rumo ao campeonato mundial de boxe, contra toda a desconfiança que acompanha a sombra de seu pai e com o apoio de Rocky (Sylvester Stallone). Sua próxima luta não será tão simples, ele precisa enfrentar um adversário que possui uma forte ligação com o passado de sua família, o que torna tudo ainda mais complexo.', '2018', '4.4', 'Sylvester Stallone, Florian Munteanu, Tessa Thompson, Dolph Lundgren', 'Warner Bros, Pictures', 'Desporto, Drama', 0),
(10, 'Hacksaw Ridge', 'IMG-63bb38c9f04245.49632936.png', 'Durante a Segunda Guerra Mundial, o médico do exército Desmond T. Doss recusa-se a pegar numa arma e matar pessoas, porém, durante a Batalha de Okinawa ele trabalha na ala médica e salva mais de 75 homens, sendo condecorado. O que faz de Doss o primeiro Opositor Consciente da história norte-americana a receber a Medalha de Honra do Congresso. Recomendados', '2016', '4.6', 'Andrew Garfield, Luke Bracey', 'Cross Creek Pictures', 'Drama, História, Guerra', 0),
(11, 'The Nun - A Freira Maldita', 'IMG-63bb3985401fd3.73689731.jpg', 'Quando uma jovem freira enclausurada numa abadia na Roménia se suicida, um sacerdote com um passado assombrado e uma noviça no limiar dos seus votos finais, são enviados pelo Vaticano para investigar este acontecimento. Juntos descobrem o segredo profano da Ordem, arriscando não só as suas vidas mas também as suas próprias almas e fé.', '2018', '2.8', 'Taissa Farmiga, Bonnie Aarons, Jonas Bloquet, Demiãn Bichir, Vera Farmiga', 'Atomic Monster Productions', 'Terror, Thriller, Mistério', 1),
(12, 'Missão: Impossível - Fallout', 'IMG-63bb3a3b887949.73505007.jpg', 'As melhores intenções muitas vezes voltam para assombrá-lo. Em MISSÃO:IMPOSSÍVEL - EFEITO FALLOUT, Ethan Hunt (Tom Cruise) e sua equipe do IMF (Alec Baldwin, Simon Pegg, Ving Rhames), na companhia de aliados conhecidos (Rebecca Ferguson, Michelle Monaghan), estão em uma corrida contra o tempo depois que uma missão dá errado. Henry Cavill, Angela Basset e Vanessa Kirby são as novidades do elenco, com Christopher McQuarrie de volta à direção.', '2018', '4.8', 'Tom Cruise, Rebecca Ferguson, Simon Pegg, Henry Cavill', 'Paramount Pictures', 'Ação, Aventura, Thriller', 1),
(13, 'Deadpool 2', 'IMG-63bc591662dfb6.47805907.jpg', 'O mercenário mutante Foul-mouthed Wade Wilson (AKA. Deadpool), reúne uma equipe de colegas mutantes para proteger um menino com habilidades sobrenaturais do cyborg brutal e viajante do tempo, Cable.', '2018', '4.4', 'Ryan Reynolds, Josh Brolin, Zazie Beetz, Julian Dennison', 'Marvel Entertainment', 'Ação, Aventura, Comédia', 0),
(14, 'Jumanji: Bem-Vindos à Selva', 'IMG-63bc59aec55383.11376497.jpg', 'Quatro adolescentes são sugados para um jogo mágico, e a única maneira que podem escapar é trabalhar juntos para terminar o jogo.', '2017', '4.0', 'Dwayane Johnson, Jack Black, Kevin Hart, Karen Gillan', 'Columbia Pictures', 'Ação, Aventura, Comédia', 1),
(15, 'Venom', 'IMG-63bc5a8abb2800.13162076.jpg', 'Eddie Brock é um jornalista que investiga o misterioso trabalho de um cientista, suspeito de utilizar cobaias humanas em experimentos mortais. Quando ele acaba entrando em contato com um simbionte alienígena, Eddie se torna Venom, uma máquina de matar incontrolável, que nem ele pode conter.', '2018', '3.4', 'Tom Hardy, Tom Holland, Michelly Williams, Woody Harrelson', 'Columbia Pictures', 'Ação, Ficção Científica', 1),
(16, 'Doutor Estranho', 'IMG-63bc5b4d6a34e4.56786093.jpg', 'A história de um ex-neurocirurgião que, depois de ter sua carreira destruída em um acidente, começa uma nova vida. Ele se torna discípulo de um grande feiticeiro para se tornar o Mago Supremo e proteger a Terra contra ameaças místicas.', '2016', '3.8', 'Benedict Cumberbatch, Benedict Wong, Wong Rachel McAdams, Chiwetel Ejiofor', 'Marvel Studios', 'Ação, Aventura, Fantasia', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `profilePic` varchar(255) DEFAULT NULL,
  `age` int(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nTel` int(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `role` text NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `profilePic`, `age`, `email`, `password`, `nTel`, `address`, `role`, `active`) VALUES
(1, 'Diogo Magalhães', 'IMG-63bc569c7f9c68.64218283.jpg', 20, 'josedmagalhaes100809@gmail.com', '7b71542daf8cbaf41a3867d6bf0b6eff', 913245292, 'Rua de Nossa Senhora de Fatima', 'Owner', 1),
(2, 'Miguel Carvalho', 'IMG-63bbe227e0aef9.94859412.jpg', 19, 'carvalhomiguel286@gmail.com', '7b71542daf8cbaf41a3867d6bf0b6eff', 935978990, 'Rua Capitão Salgueiro Maia n100 Madalena', 'Owner', 1),
(3, 'João Lemos', NULL, 19, 'joaolemos@gmail.com', '7b71542daf8cbaf41a3867d6bf0b6eff', 917119258, 'Rua do Leminhos', 'User', 1),
(4, 'Diana Carvalho', 'IMG-63bb352e928b07.98256658.jpeg', 18, 'dianacarvalho@gmail.com', '7b71542daf8cbaf41a3867d6bf0b6eff', 915486830, 'Rua Capitão Salgueiro Maia n100 Madalena', 'User', 1),
(5, 'Leonel Carvalho', NULL, 20, 'leonelcarvalho134@gmail.com', '7b71542daf8cbaf41a3867d6bf0b6eff', 910915725, 'Rua do Leonel', 'User', 1),
(6, 'Tiago Ribeiro', NULL, 19, 'tiagot7fut@gmail.com', '415a519f5b2bf4c5a4ea6df9ca6e60f0', 913614222, 'Rua do Tiaguinho', 'User', 1),
(7, 'José', 'IMG-63bfeb474cbbd8.76124021.jpg', 83, '8210125@estg.ipp.pt', '2930dc18431782a40ed7ac6765ad79fe', 913245293, 'Lousada, nº64', 'User', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aluguer`
--
ALTER TABLE `aluguer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movieId` (`movieId`,`userId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aluguer`
--
ALTER TABLE `aluguer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aluguer`
--
ALTER TABLE `aluguer`
  ADD CONSTRAINT `aluguer_ibfk_1` FOREIGN KEY (`movieId`) REFERENCES `movie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `aluguer_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
