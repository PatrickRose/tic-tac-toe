import { z } from 'zod';

// Manually write the types out
// We have two tables, and it's not really worth generating these automatically

export const userDecode = z.object({
    id: z.number(),
    name: z.string(),
    email: z.string(),
});

export const gameDecode = z.object({
    id: z.number(),
    player_1_id: z.number(),
    player_2_id: z.number().nullable(),
    moves: z.array(z.number()),
    player1: userDecode.optional(),
    player2: userDecode.optional(),
});

export type Game = z.infer<typeof gameDecode>;
export type User = z.infer<typeof userDecode>;
